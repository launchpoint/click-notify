<?
require_access('admin');

$template = NotificationTemplate::find_by_id($params['id']);

$new_var = NotificationTemplateVariable::new_model_instance( array(
  'attributes'=>array(
    'id'=>'new',
    'notification_template_id'=>$template->id
  )
));

if (is_postback())
{
  $valid = true;
  foreach($params['notification_template']['notification_template_variables'] as $id=>$arr)
  {
    if(!is_array($arr)) continue;
    if ($id=='new')
    {
      if (trim($arr['name'])!='')
      {
        $new_var->id=null;
        $new_var->update_attributes($arr);
        $valid = $valid || $new_var->is_valid;
      }
    } else {
      $v = $template->find_notification_template_variable_by_id($id);
      if ($arr['name']=='')
      {
        $v->delete();
      } else {
        $v->update_attributes($arr);
        $valid = $valid || $v->is_valid;
      }
    }
    $template->purge('notification_template_variables');
  }
  if ($valid)
  {
    flash_next("Variables updated.");
    redirect_to(edit_notification_template_url($template));
  }
}