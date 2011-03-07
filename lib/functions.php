<?

function notify($to, $tag, $data=array())
{
  global $current_notify_info;

  $current_notify_info = array('template_name'=>$tag);
  
  $template = NotificationTemplate::find_by_tag($tag);
  if (!$template)
  {
    $template = NotificationTemplate::create( array(
      'attributes'=>array(
        'name'=>humanize($tag),
        'tag'=>$tag
      )
    ));
  }
  $template->data = $data;
  if (!is_array($to)) $to = array($to);
  for($i=0;$i<count($to);$i++)
  {
    if(!is_object($to[$i]))
    {
      $to[$i] = User::new_model_instance( array(
        'attributes'=>array(
          'email'=>$to[$i],
        )
      ));
    }
  }
  foreach($to as $user)
  {
    $template->data['to'] = $user;
    event('notify', array('to'=>$user, 'template'=>$template));
  }
}

function apply_vars($s, $vars, $data=null, $escape_html=false)
{
  global $current_notify_info, $notify_info;
  $notify_info = $data;
  
  if (!$data) return $s;
  foreach(array_keys($data) as $k) if (is_numeric($k)) click_error("Your array should be key/value only, it contains other elements.", array($s, $data));
  extract($data);
  foreach($vars as $var)
  {
    $current_notify_info['var'] = $var;
    try
    {
      $regex = preg_quote($var->name);
      if (!preg_match("/#$regex#/", $s)) continue;
      set_error_handler('notify_error_handler');
      $val = eval("return {$var->php};");
      restore_error_handler();
      if (is_array($val)) $val = join($val, "\n");
      if($escape_html) $val = simple_format($val,false);
      $val = str_replace("\$", "\\$", $val);
      $s = preg_replace("/#$regex#/", $val, $s);
    } catch(Exception $e) {
      click_error("Template error with $var->name.", array($s, $vars));
    }
  }
  return $s;
}

function notify_error_handler($errno, $errstr, $errfile, $errline)
{
  global $current_notify_info, $notify_info;
  restore_error_handler();
  dprint($current_notify_info);
  click_error("Invalid template variable {$current_notify_info->name}.", array('data'=>$current_notify_info, 'all_data'=>$notify_info));
}