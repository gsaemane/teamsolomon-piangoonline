<?php namespace Rainlab\Notify\Models;

use Model;
use Exception;
use Queue;
use SystemException;
use Rainlab\Notify\Classes\ScheduledAction;

/**
 * RuleAction Model
 */
class RuleAction extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'rainlab_notify_rule_actions';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [];

    /**
     * @var array List of attribute names which are json encoded and decoded from the database.
     */
    protected $jsonable = ['config_data'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'notification_rule' => [NotificationRule::class, 'key' => 'rule_host_id'],
    ];

    public function triggerAction($params, $scheduled = true)
    {
        try {
            $actionObject = $this->getActionObject();

            // Check if action is muted in which case we don't proceed sending a notification
            if (method_exists($actionObject, 'isMuted') && $actionObject->isMuted()) {
                return;
            }

            // Apply action schedule
            if ($scheduled && $schedule = $this->getSchedule()) {
                // We delay the execution using Queues. When dequeued
                // ScheduledAction will call this triggerAction
                // function with $scheduled=false
                Queue::later($schedule,  new ScheduledAction($this, $params));
            }
            else {
                // We trigger the action
                $actionObject->triggerAction($params);
            }
        }
        catch (Exception $ex) {
            // We could log the error here, for now we should suppress
            // any exceptions to let other actions proceed as normal
            traceLog('Error with ' . $this->getActionClass());
            traceLog($ex);
        }
    }

    /**
     * Extends this model with the action class
     * @param  string $class Class name
     * @return boolean
     */
    public function applyActionClass($class = null)
    {
        if (!$class) {
            $class = $this->class_name;
        }

        if (!$class) {
            return false;
        }

        if (!$this->isClassExtendedWith($class)) {
            $this->extendClassWith($class);
        }

        $this->class_name = $class;
        return true;
    }

    public function beforeSave()
    {
        $this->setCustomData();
    }

    public function afterSave()
    {
        // Make sure that this record is removed from the DB after being removed from a rule
        $removedFromRule = $this->rule_host_id === null && $this->getOriginal('rule_host_id');
        if ($removedFromRule && !$this->notification_rule()->withDeferred(post('_session_key'))->exists()) {
            $this->delete();
        }
    }

    public function applyCustomData()
    {
        $this->setCustomData();
        $this->loadCustomData();
    }

    protected function loadCustomData()
    {
        $this->setRawAttributes((array) $this->getAttributes() + (array) $this->config_data, true);
    }

    protected function setCustomData()
    {
        if (!$actionObj = $this->getActionObject()) {
            throw new SystemException(sprintf('Unable to find action object [%s]', $this->getActionClass()));
        }

        /*
         * Spin over each field and add it to config_data
         */

        $metaAttributes = [
            'action_text',
            'schedule_type',
            'schedule_delay',
            'schedule_delay_factor',
        ];

        $formAttributes = [];
        $config = $actionObj->getFieldConfig();
        if (isset($config->fields)) {
            $formAttributes = array_keys($config->fields);
        }

        $fieldAttributes = array_merge($formAttributes, $metaAttributes);

        $dynamicAttributes = array_only($this->getAttributes(), $fieldAttributes);
        $this->config_data = $dynamicAttributes;

        $this->setRawAttributes(array_except($this->getAttributes(), $fieldAttributes));
    }

    public function afterFetch()
    {
        $this->applyActionClass();
        $this->loadCustomData();
    }

    public function getText()
    {
        if (strlen($this->action_text)) {
            return $this->action_text;
        }

        if ($actionObj = $this->getActionObject()) {
            return $actionObj->getText();
        }
    }

    public function getSchedule()
    {
        if ($this->schedule_type !== 'delayed') {
            return false;
        }

        if (!is_numeric($this->schedule_delay) || !is_numeric($this->schedule_delay_factor)) {
            return false;
        }

        $delay = (int) $this->schedule_delay;
        $delay_factor = (int) $this->schedule_delay_factor;

        return abs($delay * $delay_factor);
    }

    public function getActionObject()
    {
        $this->applyActionClass();

        return $this->asExtension($this->getActionClass());
    }

    public function getActionClass()
    {
        return $this->class_name;
    }
}
