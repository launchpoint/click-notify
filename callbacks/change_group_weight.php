<?

$group = NotificationTemplateGroup::find_by_id($params['id']);

$groups = NotificationTemplateGroup::find_all( array(
  'order'=>'weight'
));

for($i=0;$i<count($groups);$i++)
{
  if($groups[$i]->id != $group->id) continue;
  switch($params['direction'])
  {
    case 'up':
      if($i>0)
      {
        $groups[$i-1]->weight++;
        $group->weight--;
        $groups[$i-1]->save();
        $group->save();
      }
      break;
    case 'down':
      if($i<count($groups)-1)
      {
        $groups[$i+1]->weight--;
        $group->weight++;
        $groups[$i+1]->save();
        $group->save();
      }
      break;
  }
}

redirect_to(list_notification_template_groups_url());