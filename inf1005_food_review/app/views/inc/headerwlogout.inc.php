<!-- <header class="text-white text-center">
    <h1>My Website</h1>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/home">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/profile">My Account</a>
                        <a class="dropdown-item" href="/resetpassword">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header> -->

<link href="/public/css/header.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <a class="navbar-brand" href="/home"><img id="logo" src="/Images/logo.png" alt="peoplereivewmovies_logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" 
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="/about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact</a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Profile
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="/profile">My Account</a>
              <a class="dropdown-item" href="/resetpassword">Change Password</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/logout">Logout</a>
          </div>
      </li>
    </ul>
  </div>
</nav>
