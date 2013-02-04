<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<p><?php $this->gen_lib->display_messages(); ?></p>
<table id="users-tbl" class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Username</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Role</th>
			<th>Created</th>
			<th>Verified</th>
			<th>Operations</th>
		</tr>
	</thead>
	<tbody>
		
			<?php foreach ($users as $user) {
				$output = "<tr>";
					$output .= "<td>{$user->username}</td>";
					$output .= "<td>{$user->first_name}</td>";
					$output .= "<td>{$user->last_name}</td>";
					$output .= "<td>{$user->email}</td>";
					$output .= "<td>{$user->role->name}</td>";
					$output .= "<td>{$user->created_at}</td>";
					$output .= "<td>";
					if ($user->verif == 1) {
						$output .= '<i class="icon-ok success-color"> ok</i>';
					}
					elseif ($user->verif == 'ERROR') {
						$output .= '<i class="icon-remove error-color"> wait</i>';
					}
					else{
						$output .= '<i class="icon-flag notice-color"> error</i>';
					}
					$output .= "</td>";
					$output .= "<td>";
					if ($this->current_user->id != $user->id) {
						$output .= '<a title="Remove User" href="'.base_url("users/{$user->id}/destroy").'"><i class="icon-remove-sign"></i></a>';
					}
					$output .= "</td>";
					
				$output .= "</tr>";
				echo $output;	
			}
			?>
	</tbody>
</table>