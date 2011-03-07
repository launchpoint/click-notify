<?

$group = NotificationTemplateGroup::find_by_id($params['id']);

if($group)
{
  $templates = NotificationTemplate::find_all_by_notification_template_group_id($group->id);
  foreach($templates as $t)
  {
    $t->notification_template_group_id = null;
    $t->save();
  }
  $group->delete();
  flash_next("Group deleted.");
  redirect_to(list_notification_template_groups_url());
}