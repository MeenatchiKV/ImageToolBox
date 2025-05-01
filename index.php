<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image ToolBox</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="style.css"/>
        <link 
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    </head>
    <body>
    
      <?php include('header.html'); ?>

<br>
    <div class="container">
    <h3>Convert to Grey Scale</h3>
    <form id="uploadForm" method="post" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <td>
                
                    <div class="drag-area" id="preview">
                        <div class="icon">
                            <i class="fas fa-images"></i>
                        </div>
            
                        <span class="header"> Drag & Drop </span>
                        <span class="header"> or <span class="button">browse</span></span>
                        <input class="input" type="file" name="file" id="file" hidden/>
                        <span class="support">Supports: JPEG, JPG and PNG</span>
                    </div>
            </td>
            <td>
                <div class="view-area">
                    <div class="icon">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <p> File Name: <span id="fname"> None </span></p>
        </tr>
    <tr>
        <td>
            <div class="submit">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <button type="button" id="greyscaleBTN" class="btn btn-outline-primary">Convert to Grey Scale</button>
                </div> 
            </div>
        </td>
        <td>
            <div class="download">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a id="download" type="button" class="btn btn-outline-primary" download>Download</a>
                </div> 
            </div>
        </td>
        <td>
            <div class="Reset">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a id="reset" href="" type="button" class="btn btn-outline-primary">Reset</a>
                </div> 
            </div>
        </td>
    </tr>
        
        
    </table> 
</form> 
    </div>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
   
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('greyscaleBTN').onclick = () => {
        var fname=document.getElementById("fname").textContent;
$.ajax({
    type: "POST",
    url: "http://localhost:5000/greyscale/"+fname,
    contentType: "application/json",
    dataType: "text",
    data: JSON.stringify({
        o: fname
    }),
    error: function(xhr, status, error) {
        //displayOutput();
    },
    success: function(response){
        document.getElementById("download").href = response;
        displayOutput(response);
    }    

});
    }  
});

    </script>
    </body>
</html>