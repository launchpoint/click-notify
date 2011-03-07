<?
require_access('admin');

$groups = NotificationTemplateGroup::find_all( array(
  'order'=>'weight'
));

if (p('id'))
{
  $template = NotificationTemplate::find_by_id($params['id']);
} else {
  $template = NotificationTemplate::new_model_instance( array(
    'attributes'=>array(
      'name'=>'New template'
    )
  ));
}

$is_new = $template->is_new;

if (p('t'))
{
  $template->data = array();
  foreach($template->notification_template_variables as $k=>$var)
  {
    $template->data[$var->name] = "**{$var->name}**";
    $template->notification_template_variables[$k]->php = "\$$var->name";
  }
  event('notify', array('to'=>$current_user, 'template'=>$template, 'test'=>true));
  flash_next("Test notification created.");
  redirect_to(edit_notification_template_url($template));
}


if (is_postback() && array_key_exists('notification_template', $params))
{
  $template->update_attributes($params['notification_template']);
  if ($template->is_valid)
  {
    if ($is_new)
    {
      flash_next('Notification template created.');
      redirect_to(edit_notification_template_url($template));
    } else {
      flash('Saved');
    }
  }
}

$plugins = event('notification_template_render_plugins', array('template'=>$template),true);
