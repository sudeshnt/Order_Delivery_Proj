<?php $__env->startSection('content'); ?>
  <!-- <?php if($message=='register_success'): ?> -->

 <!--  <?php endif; ?> -->

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form role="form" method="post" action="<?php echo e(url('/doRegister')); ?>">
      <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">    
      <div class="form-group has-feedback">
        <input type="text" name="name" class="form-control" placeholder="Full name" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group">
        <!-- <label>Role</label> -->
        <select class="form-control select2" name="role_id" style="width: 100%;" placeholder="Role">
          <option value="1">Admin</option>
          <option value="2">Secretory</option>
          <option value="3">Cashier</option>
        </select>
    </div>
      <div class="form-group has-feedback">
        <?php if($user_already_exist==true): ?>
               <label style="color: red;">username already exists!</label>
        <?php endif; ?>
        <input type="text" name="username" class="form-control" placeholder="Username" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?php if($errors->first('password')): ?>
                     <label style="color: red;"><?php echo e($errors->first('confirm_password')); ?></label>
        <?php endif; ?>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?php if($errors->first('confirm_password')): ?>
               <label style="color: red;"><?php echo e($errors->first('confirm_password')); ?></label>
        <?php endif; ?>
        <input type="password" name="confirm_password" class="form-control" placeholder="Retype password" required>
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
 

  
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>