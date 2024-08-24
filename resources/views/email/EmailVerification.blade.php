{{-- @component('mail::message')
    <h3>Hello {{$user['firstName']}}!</h3>
    <p>Please click the button below to verify your email address.</p>

    @component('mail::button',['url'=>url('http://localhost:5174/verify/'.$user['remember_token'])])
Verify Email Address
    @endcomponent


    <p>If you did not create an account, no further action is required</p>
    Regards <br/> Steven
@endcomponent --}}

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed:wght@400;500;600;700&family=Josefin+Sans:wght@100;200;300;400;500;700&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:wght@100;300&display=swap"
      rel="stylesheet"
    />
    <style>
      .roboto-thin {
        font-weight: 100;
        font-style: normal;
      }

      .roboto-light {
        font-family: "Roboto", sans-serif;
        font-weight: 300;
        font-style: normal;
      }

      * {
        font-family: "Roboto", sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      .container {
        min-height: 60vh;
        margin: 3rem 2rem;
      }
  


      .container .header {
       padding: 20px 5px;
       text-align: center;
       width: 100%;
        background:  linear-gradient( rgb(177, 117, 172),rgb(177, 156, 117));
      }
      .container .header *{
        background-color: transparent;
      }
      .container .body{
        padding: 2rem;
      }

      .container .greeting {
        font-size: 18px;
        font-weight: 500;
        letter-spacing: 1px;
        margin-bottom: 1rem;
      }

.button_container{
      text-align: center;
      margin: 2rem 0;
      }
      .button_container a{
      border:none;
      background-color: rgb(41, 40, 40);
      color: white;
      padding: 0.5rem 2rem;
      border-radius: 4px;
      font-size: 16px;
      font-weight: 500;
      text-decoration: none !important;
      }

      .container p {
        font-weight: 400;
        font-size: 15px;
        color: rgb(161, 161, 161);
        margin: 10px 0;
      }
      .container .regard {
        margin: 1rem 0;
      }

      .border {
        margin: 1rem 0;
        background-color: rgb(235, 232, 232) !important;
        height: 1px;
      }

      ul {
        list-style-type: none;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
      }
      li {
        margin: 0 15px;
      }

      .contact{
      margin-bottom: 10px;
      }

    a{
    text-decoration: none;
    }

        @media screen and (min-width: 768px) {
        .container {
          width: 50%;
          margin: 3rem auto;
        }
      }
    </style>

   
  </head>
  <body>
    <div class="container">
      <div class="header">
        <img
          width="150"
          height="60"
          class="cart"
          src="https://res.cloudinary.com/dz8elpgwn/image/upload/v1712417609/1712417480826_l3svvk.png"
          alt=""
        />
       
        <img
          width="60"
          height="50"
          class="cart"
          src="https://res.cloudinary.com/dz8elpgwn/image/upload/v1712417609/1712417509278_nhfru4.png"
          alt=""
        />
      </div>
      <div class="body">
      <h4 class="greeting">Hello {{$user['firstName']}}!</h4>
     <p>Click the button below to verify your email address.</p>
      <div class="button_container"> 
      {{-- <a href={{'http://localhost:5174/verify/'.$user['remember_token']}} >Verify Email Address</a> --}}
      <a href={{'https://portfolio-upload-plum.vercel.app/verify/'.$user['remember_token']}} >Verify Email Address</a>
      </div>
      <p>If you did not create an account, no further action is required</p>

      <p class="regard">
        Regards <br />
        Steven
      </p>
      <div class="border"></div>

<p class="contact">For more enquiries, <b>contact us on</b></p>
        <ul>
        <li>
          <a
            href="https://www.facebook.com/sunday.stephen.3990"
            ><img
              height="20"
              width="20"
              src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/600px-Facebook_Logo_%282019%29.png"
              alt="facebook"
          /></a>
        </li>
        <li>
          <a href="https://wa.me/2348168225901"
            ><img
              height="20"
              width="20"
              src="https://w7.pngwing.com/pngs/922/489/png-transparent-whatsapp-icon-logo-whatsapp-logo-whatsapp-logo-text-trademark-grass-thumbnail.png"
              alt="whatsapp"
          /></a>
        </li>
        <li>
          <a href="http://www.linkedin.com/in/oluwagbemiga-stephen-oluwadunsin-2ba681227"
            ><img
              height="20"
              width="20"
              src="https://cdn-icons-png.flaticon.com/512/174/174857.png"
              alt="linkedin"
          /></a>
        </li>
        <li>
          <a href="https://twitter.com/Stephen93639861"
            ><img
              height="20"
              width="20"
              src="https://www.pngkey.com/png/full/2-27646_twitter-logo-png-transparent-background-logo-twitter-png.png"
              alt="twitter"
          /></a>
        </li>
        <li>
          <a href="tel:+2348168225901"
            ><img
              height="20"
              width="20"
              src="https://w7.pngwing.com/pngs/759/922/png-transparent-telephone-logo-iphone-telephone-call-smartphone-phone-electronics-text-trademark-thumbnail.png"
              alt="call"
          /></a>
        </li>
      </ul>
      </div>
    </div>
  </body>

  
</html>


