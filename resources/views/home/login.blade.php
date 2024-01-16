<html>
<link rel="stylesheet" href="css/login.css">
<html lang="en">
<body>
<section class="landing-section">
    </section>
<div class="login-box">
  <h2 style="font-size: 35px">Login</h2>
  <a href="" class="close" style="text-decoration: none; color: #fff; font-size: 50px">
    <span aria-hidden="true" style="color: #6c63ff;">&times;</span></a>
  <form method="post" action="{{ url('/api/login') }}">
    @csrf
    <div class="user-box">
      <input type="email" name="email" required="">
      <label>Username</label>
    </div>
    <div class="user-box">
      <input type="password" name="password" required="">
      <label>Password</label>
    </div>

    <button>
      Submit</button>
  </form>
  <span>New Here ?
  <a href="/signuppage" id="a">
      Sign Up Here
    </a>

</span>
<br>
<span>Forgot Password !
  <a href="/forgot-password" id="a">
      Change here
    </a>

</span>
</div>
</html>
