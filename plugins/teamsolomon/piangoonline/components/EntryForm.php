<?php namespace TeamSolomon\PiangoOnline\Components;

use Cms\Classes\ComponentBase;
use TeamSolomon\PiangoOnline\Controllers\Issues as EntryController;
use TeamSolomon\PiangoOnline\Models\Issue;
use TeamSolomon\PiangoOnline\Models\Status;

class EntryForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'EntryForm Component',
            'description' => 'Backend form used in the front-end'
        ];
    }

    /**
     * Executed when this component is initialized
     */
    public function prepareVars()
    {
        $this->page['user'] = $this->user();
        $this->page['statuses'] = Status::all();
    }


    public function onRun()
    {
        // Build a back-end form with the context of 'frontend'
        $formController = new EntryController();
        $formController->create('frontend');

        // Append the formController to the page
        $this->page['form'] = $formController;

        // Append the missing style file so that our front-end forms would look
        // just like back-end
        $this->addCss('/modules/backend/assets/css/controls.css', 'core');
    }

    public function onSave()
    {
       // return ['error' => Issue::create(post('Issue'))];
       $response = Issue::create(post('Issue'));
       if($response)
         return redirect()->refresh();
       else 
         return ['error'=>$response];
    }
    public function onUpdate()
    {
        $response = Issue::where('id', '=', post('Issue.id'))->update(post('Issue'));
       if($response)
         return redirect()->refresh();
       else 
         return ['error'=>$response];
    }

}