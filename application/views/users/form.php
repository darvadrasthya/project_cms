<?php $this->load->view('templates/admin_header'); ?>

<!-- Page Header -->
<div class="page-header	    <h1><?php echo isset($user) ? 'Edit User' : 'Create User'; ?></	
    <nav aria-label="breadcru		      <ol class="breadcr			       <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a			        <li class="breadcrumb-item"><a href="<?php echo base_url('users'); ?>">Users</			         <li class="breadcrumb-item active"><?php echo isset($user) ? 'Edit' : 'Create';		
    	</ol>
    </nav>
</div>

<div class="cont	wrapper" >
    <?php if($this->session->flas hdata		)): ?>
        <div class="alert alert-danger alert-dismissi			w">
            <?php echo $this->session->flashd			; ?>
            <button type="button" class="btn-close" data-bs-dismiss=		</butto	        </div>
 	?php endif; ?>

 		class="card">
        <			ard-body">
            <form action="<?php echo isset($user) ?  b ase_url('users/update/'.$user['user_id']) : base_url('users/stor				"post">
         					ow">
                 						>
                							                            <label class="form-label">Username <span class="te							
                            <input type="text" name="us                              value="<?php echo isset($user) ? htmlspecialchars($user['username']) : set_val						ired>
					    </d					     </div>
          						l-md-6">
         							b-3">
                            <label class="form-label">Email <span cl							label>
                            <input type="email
                                   value="<?php echo isset($user) ? htmlspecialchars($user['email'])						>" requ					       				        				                </					    <div class="row">
						 class="col-md-6">							v class="mb-3">
                            <label class="form-label">Password <?php echo isset($user) ? '' : '<sp							an>'; ?></label>
                            <input type="password" name="password" class="form-control" <							: 'requi red'; ?>>
         								et($user)): ?>
                                <small class="text-mute							nt password</sma						       					       					v>
                   						     <div class="co							      <div class="mb-3">
                         							>Confirm Password</label>
                            <input type="p						confirm					l">
  				      </				          </div>
					v>

                <						              <div 							               <div class="mb-3">
         							ass="form-label">Full Name</label>
                     _name" class="form-control" 
                                   value="<?php echo isset($user) ? htmlspeci						'] ?? '					_name')					            </div>
   						
                  							                      <div class="mb-3">							  <label class="form-label">Phone</label>
         " name="phone" class="form-control" 
                                   value="<?php echo isset($us						user['p					value('				        				/div>
           					             </div>

						ss="row">
        							md-6">
                        <div cla							            <label class="form-label">Roles</label>
								ect name ="roles[]" clas s="fo									                   <?php if(iss et($r										        <?php foreach($roles as $role): ?>
    value="<?php echo $role['role_id']; ?>"
                                            <?php echo (i											'], $user_roles)) ? 'selected' : ''; ?>>
          										echo htmls									
                    								                							foreach; ?							       <?php endif; ?>
                            </select>
      						mall cl					d Ctrl 					oles</small>
         						                   							<div class="col-md-6">
                 							                           <label class="form-								                   <select name="is_active" class="form-select">
                                <optio								ser) && $user['is_active']) ? 'selected' : ''; ?>>Active</option>
                                <option 							$user) && 						selecte					</optio				        				>
  				      </div>
                    </div>
   					

                <hr>
                <div class="d-flex justify-co						             <a href="<?php echo base_					ass="					
                        <i class="bi bi-arrow-						             </a>
                    <button type="submit" class="btn btn-primary">					     <i cl				-lg"></			o isset(		 'Updat	 'Create'; ?> User
                    </button>
                <div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('templates/admin_footer'); ?>
