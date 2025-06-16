<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title> Contact Form </title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Outfit';
    background: linear-gradient(#ffdad5, #fff7f9);
    /* max-width: fit-content; */

}
.container{
    max-width: 1000px;
    max-height: 800px;
    margin: 80px auto;
    background: rgba(246, 246, 246, 0.6); /* Lowered from 0.8 to 0.6 */
    padding: 60px 40px;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
}
.contact-continer {
    height: 100vh;
    width: 100%;
    display: flex;
    justify-content: space-around;

}

.contact-left {
    display: flex;
    flex-direction: column;
    align-items: start;
    gap: 20px;

}

.contact-left-title h2 {
    font-weight: 600;
    color: #a363aa;
    font-size: 40px;
    margin-bottom: 5px;
}

.contact-left-title hr {
    border: none;
    width: 120px;
    height: 5px;
    background-color: #a363aa;
    border-radius: 10px;
    margin-bottom: 20px;
}

.contact-inputs {
    width: 400px;
    height: 50px;
    border: none;
    outline: none;
    padding-left: 25px;
    font-weight: 500;
    color: #666;
    border-radius: 50px;
}

.contact-left textarea {
    height: 140px;
    padding-top: 15px;
    border-radius: 20px;
}

.contact-inputs :focus {
    border: 2px solid #ff994f;
}

.contact-inputs ::placeholder {
    color: #a9a9a9;
}

.contact-left button {
    display: flex;
    align-items: center;
    padding: 15px 30px;
    font-size: 16px;
    color: #fff;
    gap: 10px;
    border: none;
    border-radius: 50px;
    background: linear-gradient(270deg, #ff994f, #fa6d86);
    cursor: pointer;
}

.contact-left button i {
    height: 15px;
}

@media (max-width:800px) {
    .contact-inputs {
        width: 80vw;
    }
}

.contact-info h2 {
    font-weight: 500;
    color: #010633;
    font-size: 40px;
    margin-bottom: 5px;
}

.contact-info h3 {
    font-weight: 20;
    color: #873f8f;
    font-size: 20px;
    margin-bottom: 10px;
}

nav ul {
    float: right;
    margin-right: 10px;
    margin-left: 50px;
    text-align: right;
    margin-top: 1%;
    font-family: 'kaushan script', cursive;
}

nav ul li {
    display: inline-block;
    line-height: 80px;
    margin: 0 5px;
}

nav ul li a {
    color: white;
    font-size: 17px;
    padding: 7px 13px;
    border-radius: 3px;
    text-transform: uppercase;
}

a.active,
a:hover {
    background-color: #c52c2c;
    transition: uppercase;
}

.menu-right {
    text-align: right;
}

span {
    margin: 0 30px;
    font-size: 28px;
    cursor: pointer;
    display: none;
    color: #fefefe;
    text-align: right;
}

@media only screen and (max-width: 700px) {
    span {
        display: block;
    }
    nav ul li {
        display: block;
    }
    nav ul {
        display: none;
    }
}

.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    /* You can customize the background color */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.preloader::after {
    content: '';
    width: 50px;
    height: 50px;
    border: 4px solid #3498db;
    /* You can customize the color */
    border-radius: 50%;
    border-top: 4px solid transparent;
    animation: spin 1.5s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}


/* Add this class to hide the preloader when the page is loaded */

.loaded .preloader {
    display: none;
}

        .hover_ele2 a:hover{
            background-color:#c52c2c;
            transition:uppercase;
            color:white;
        }
    </style>
</head>

</link>

<div class="container">
    <div class="contact-continer">
        <form style="margin: 20px;" action="https://api.web3forms.com/submit" method="POST" class="contact-left">
            <div class="contact-left-title">
                <h2> Get in touch </h2>
                <hr>
            </div>
            <input type="hidden" name="access_key" value="45c5004a-1eaf-4cce-9a12-0ce21aefc52d">
            <input type="text" name="name" placeholder="Your Name" class="contact-inputs" required>
            <input type="email" name="email" placeholder="Your Email" class="contact-inputs" required>
            <textarea name="message" placeholder="Your Message" class="contact-inputs" required></textarea>
            <button type="submit">submit 
                <i class='bx bx-right-arrow-alt'></i></button>
        </form>
        <div class="contact-right">
            <div class="video-right">
                <video id="Vautoplay" width="500" muted oncanplaythrough="vplay()">
                     <source src="./images/145651 (540p).mp4" type="video/mp4">
                     <source src="./images/145651 (540p).mp4" type="video/mp4">
                 </video>
            </div>
            <div class="contact-info">
                <h2>Contact Info </h2>
                <h2> Hirkani Beauty Parlour </h2>
                <h3><i class='bx bxs-user'>Dipali Kore</i></h3>
                <h3><i class='bx bxs-phone-call'></i> 8390293434</h3>
                <h3><i class='bx bxs-envelope'></i> dipalicore1497@gmail.com</h3>
                <h3><i class='bx bxs-location-plus'></i>Hirkani Beauty Parlour,Chougale Building,Walva Road,Bidri,Kolhapur,Maharashtra 416208</h3>
            </div>
        </div>

    </div>
</div>

    <div class="preloader"></div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
      document.body.classList.add("loaded");
        }, 500); // Set the time you want the preloader to be displayed (3 seconds in this case)
     });
    </script>
    <script>
        let set_active = document.getElementById("contact");
        set_active.className = "active";
        let set_title = document.getElementById("nav_title");
        set_title.style.display = "none";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        function vplay(){
            var a =    document.getElementById("Vautoplay");
            a.play();
            a.loop = true;
        }
    </script>
</body>


</html>