<div style='height:10px; background:#dc3545;'></div>
<nav style="background: #0f0f3e;" class='navbar navbar-expand-lg navbar-dark'>
  <?php if ( isset( $_SESSION[ 'UserId' ] ) ) : ?>
  <div class='container'>
    <a href='index.php?page=1' class='navbar-brand'> THE POOL OF WRITERS</a>
    <button class='navbar-toggler' data-toggle='collapse' data-target='#navbarcollapse'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarcollapse'>
      <ul class='navbar-nav mr-auto'>
        <li class='nav-item'>
          <a href='about-us.php' class='nav-link'>About Us</a>
        </li>
        <li class='nav-item'>
          <a href='contact-us.php' class='nav-link'>Contact Us</a>
        </li>
        <li class='nav-item'>
          <a href='admin-dashboard.php' class='nav-link'>Dashboard</a>
        </li>
        <li class='nav-item'>
          <a href='logout.php'
            class='nav-link nav-link hide_login_link_large_screen show_login_link_large_screen text-danger'>
            <i class='fas fa-user-times'></i> Logout</a>
        </li>
      </ul>
      <ul class='navbar-nav ml-auto'>
        <form class='form-inline d-sm-block' action='index.php'>
          <div class='form-group custom_search_input_text_container'>
            <input class='form-control mr-2 custom_search_input_text' type='text' name='Search'
              placeholder='Search post here' autocomplete='off' value=''>
            <button class="SearchButton" style='background:#dc3545; padding: 7px; color: #fff; border-radius: 6px;'
              name='SearchButton'>Go</button>
          </div>
        </form>
      </ul>
    </div>
  </div>
  <?php else : ?>
  <div style="background: #0f0f3e;" class='container'>
    <a href='index.php?page=1' class='navbar-brand'> THE POOL OF WRITERS</a>
    <button class='navbar-toggler' data-toggle='collapse' data-target='#navbarcollapse'>
      <span class='navbar-toggler-icon'></span>
    </button>
    <div class='collapse navbar-collapse' id='navbarcollapse'>
      <ul class='navbar-nav mr-auto'>
        <li class='nav-item'>
          <a href='about-us.php' class='nav-link'>About Us</a>
        </li>
        <li class='nav-item'>
          <a href='contact-us.php' class='nav-link'>Contact Us</a>
        </li>
        <li class='nav-item'>
          <a href='login.php' class='nav-link nav-link hide_login_link_large_screen show_login_link_large_screen'
            style="color: #fff; text-transform: uppercase; font-weight: bold;">
            Login
          </a>
        </li>
      </ul>
      <ul class='navbar-nav ml-auto'>
        <form class='form-inline d-sm-block' action='index.php'>
          <div class='form-group custom_search_input_text_container'>
            <input class='form-control mr-2 custom_search_input_text' type='text' name='Search'
              placeholder='Search post here' autocomplete='off' value=''>
            <button class="SearchButton" style='background:#dc3545; padding: 7px; color: #fff; border-radius: 6px;'
              name='SearchButton'>Go</button>
          </div>
        </form>
      </ul>
    </div>
  </div>

  <?php endif ?>
</nav>
<div style='height:10px; background:#dc3545;'></div>