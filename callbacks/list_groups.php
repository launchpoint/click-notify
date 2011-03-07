<?

$groups = NotificationTemplateGroup::find_all( array(
  'order'=>'weight'
));

$new_group = NotificationTemplateGroup::new_model_instance( array(
  'attributes'=>array(
    'weight'=>(count($groups)>0) ? $groups[count($groups)-1]->weight+1 : 0
  )
));

if(is_postback())
{
  $new_group->update_attributes($params['notification_template_group']);
  if($new_group->is_valid)
  {
    flash("Group added.");
    $groups = NotificationTemplateGroup::find_all( array(
      'order'=>'weight'
    ));
    
    $new_group = NotificationTemplateGroup::new_model_instance();   
  }
}