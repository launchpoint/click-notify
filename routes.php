<?

map('content', 'admin/notification_templates', 'list', 'list_notification_templates');
map('content', 'admin/notification_templates/:id/edit', 'edit', 'edit_notification_template');
map('content', 'admin/notification_templates/:id/edit_variables', 'edit_variables', 'edit_notification_template_variables');
map('content', 'admin/notification_templates/new', 'edit', 'new_notification_template');
map('api', 'api/notification_templates/:id/toggle/:name', 'toggle_preference', 'toggle_notifier_preference');
map('content', 'admin/notification_templates/groups/list', 'list_groups', 'list_notification_template_groups');
map('content', 'admin/notification_templates/groups/change_weight/:id/:direction', 'change_group_weight', 'change_notification_template_group_weight');
map('content', 'admin/notification_templates/groups/delete/:id', 'delete_group', 'delete_notification_template_group');