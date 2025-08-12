<div class="sidebar">
    
        <form class="d-flex mt-5">
        <input class="form-control  p-1" type="text" placeholder="Search">
        <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
      </form>
    <ul class="list-group list-group-flush bg-dark">
      <li class="list-group-item bg-dark"><a href="adminDashboard?users" class="text-decoration-none text-light"><i class="fas fa-users"></i> Users</a></li>
      <li class="list-group-item bg-dark"><a href="adminDashboard?questions" class="text-decoration-none text-light"><i class="fas fa-question-circle"></i> Question</a></li>
      <li class="list-group-item bg-dark"><a href="adminDashboard?category" class="text-decoration-none text-light"><i class="fas fa-window-restore"></i> Category</a></li>
      <li class="list-group-item bg-dark"><a href="adminDashboard?leaderboard" class="text-decoration-none text-light"><i class="fas fa-trophy"></i> Leaderboard</a></li>
      <li class="list-group-item bg-dark"><a href="adminDashboard?changePass" class="text-decoration-none text-light"><i class="fas fa-user"></i> Change Details</a></li>
      <li class="list-group-item bg-dark"><a href="<?= APPURL?>/auth/logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      
  </ul>
  </div>