namespace CoolDudes\FrontEndForms\Components;
use Cms\Classes\ComponentBase;
class EntryForm extends ComponentBase
{
  public function componentDetails()
  {
    return [
      ‘name’ => ‘EntryForm Component’,
      ‘description’ => ‘Backend form used in the front-end’
    ];
  }
  public function onRun()
  {
    // Build a back-end form with the context of ‘frontend’
  $formController = new \Mja\Forms\Controllers\Entries();
  $formController->create(‘frontend’);
  // Append the formController to the page
  $this->page[‘form’] = $formController;
  }
}