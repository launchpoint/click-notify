<?

$nt = NotificationTemplate::find_by_id($params['id']);
$p = NotifierPreference::find_or_create_by( array(
  'conditions'=>array('notification_template_id = ? and user_id = ? and name = ?', $nt->id, $current_user->id, $params['name']),
  'attributes'=>array(
    'notification_template_id'=>$nt->id,
    'user_id'=>$current_user->id,
    'name'=>$params['name'],
    'is_enabled'=>1
  )
));
$p->is_enabled = ($p->is_enabled == 1) ? (0) : (1);
$p->save();
echo "saved.";