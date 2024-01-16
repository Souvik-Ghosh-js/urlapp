<html>
<link rel="stylesheet" href="css/login.css">
<html lang="en">
<body>
<div class="login-box">
  <h2  style="font-size: 35px">Signup</h2>
  <a href="" class="close" style="text-decoration: none; color: #fff; font-size: 50px">
    <span aria-hidden="true" style="color: #6c63ff;">&times;</span></a>
  <form action="{{ url('/api/verify') }}" method="post">
    @csrf
    <div class="user-box">
      <input type="text" name="name" required="">
      <label>Username</label>
    </div>
    <div class="user-box">
      <input type="email" name="email" required="">
      <label>Email Id.</label>
    </div>
    <!-- <div class="user-box">
      <input type="password" name="password" required="">
      <label>Password</label>
    </div> -->

        <button>
      Signup
</button>

  </form>
  <span>already a User ?
  <a href="/loginpage" id="a">
      Login Here
    </a>
</span>
</div>
</html>
