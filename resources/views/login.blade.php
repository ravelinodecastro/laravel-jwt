<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="col-md-6 mt-5">
      <form onsubmit="login()">
        <div class="row mb-3">
          <label for="email" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email" class="form-control" id="email">
          </div>
        </div>
        <div class="row mb-3">
          <label for="password" class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" id="password">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
        <a href="/register">Sign up</a>
      </form>
    </div>
  </div>

<script>
  window.onload = function(){
    document.querySelector('form').addEventListener('submit', event => {
    event.preventDefault();
    });
  }
  async function login(){
      await fetch('/api/login', {
          method: 'POST',
          headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
          },
          body: JSON.stringify({email: document.getElementById('email').value, password: document.getElementById('password').value})
      })
      .then((res)=>{ return res.json(); })
      .then((data)=>{
          document.cookie = `jwt_token= ${data.data.access_token}`;
          window.open("/", "_self");
      })
      .catch((error)=>{
          alert(error)
          console.error(error)
      })

  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>