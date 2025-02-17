<h3><?php _e('Additional Roles', 'aikon-role-manager'); ?></h3>
<p><?php _e('Select additional roles for this user.', 'aikon-role-manager'); ?></p>

<table class="form-table">
    <tr>
        <th>
            <label for="additional_roles"><?php _e('Additional Roles', 'aikon-role-manager'); ?></label>
        </th>
        <td>
            <ul>
                <?php foreach($roles as $role => $data): if($role == $primary_role) continue; ?>
                    <li>
                        <label>
                            <input 
                                type="checkbox" 
                                <?php if(!$can_edit_roles) echo 'disabled'; ?>
                                name="<?php echo $form;?>[]" 
                                value="<?php echo $role; ?>" <?php echo in_array($role, $user_other_roles) ? 'checked' : ''; ?>
                            >
                            <?php echo $data['name']; ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </td>
    </tr>
</table>