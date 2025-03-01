<footer class="f-footer">
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <style>
        .f-footer {
            background-color: #333;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .f-logo {
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
        }

        .f-footer-links ul {
            list-style: none;
            display: block;
            padding: 0;
            margin: 0;
        }

        .f-footer-links ul li {
            margin-bottom: 10px;
        }

        .f-footer-links ul li a {
            font-family: "Montserrat" , sans-serif;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .f-footer-links ul li span {
            font-family: "Montserrat", sans-serif;
            font-size: 18px;
            color: white;
        }
    </style>

    <div class="f-logo">FITFUSION</div>
    <div class="f-footer-links">
        <ul>
            <li><a href="https://www.instagram.com/autisticdylan/" target="_blank">Follow us on Instagram</a></li>
            <li><span>Phone: +123-456-7890</span></li>
            <!-- span tags are generally used for line-level content, such as short strings or individual words. div tags, on the other hand, are generally used to group larger blocks of code together, such as paragraphs or entire sections. So this is what I found.. and I will use span tag for it even though I will probably use div tag if I didn't know span exist-->
        </ul>
    </div>
</footer>
