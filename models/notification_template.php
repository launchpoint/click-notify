<?

function notification_template_apply_vars($nt, $s, $escape_html=false)
{
  return apply_vars($s, $nt->notification_template_variables, $nt->data, $escape_html);
}

function notification_template_extract_variables($nt, $obj, $arr)
{
  $matches = array();
  foreach($arr as $field)
  {
    preg_match_all('/#(\w+)#/m', $obj->$field, $matches);
    if (count($matches)>1)
    {
      for($i=1;$i<count($matches);$i++)
      {
        foreach($matches[$i] as $match)
        {
          if (!$nt->find_notification_template_variable_by_name($match))
          {
            $o = NotificationTemplateVariable::create( array(
              'attributes'=>array(
                'notification_template_id'=>$nt->id,
                'name'=>$match,
                'description'=>humanize($match),
                'php'=>'$'.$match
              )
            ));
            $nt->notification_template_variables[] = $o;
          }
        }
      }
    }
  }
}


function notification_template_preferences_for__d($nt, $u)
{
  $p = NotifierPreference::find_all(array(
    'conditions'=>array('notification_template_id = ? and user_id = ?', $nt->id, $u->id),
  ));
  return $p;
}

function notification_template_is_enabled_for__d($nt, $u, $name)
{
  if ($nt->is_system) return true;
  if(!is_object($u) || !$u->id) return true;
  $p = get_collection_member_by_prop($nt->preferences_for($u), 'name', $name);
  if (!$p) return $nt->is_active_default;
  return $p->is_enabled;
}