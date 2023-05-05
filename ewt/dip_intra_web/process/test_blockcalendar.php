<!DOCTYPE html>
<html>
  
<head>
    <link href=
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
          rel='stylesheet'>
    <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
    </script>
    <script src=
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js">
    </script>
    <style>
        h1 {
            color: green;
        }
          
        .ui-datepicker {
            width: 12em;
        }
    </style>
</head>
  
<body>
    <center>
        <h1>GeeksforGeeks</h1>
        <h4>jQuery UI beforeShowDay</h4> Start Date:
        <input type="text" id="my_date_picker1">
        <script>
            $(document).ready(function() {
                $(function() {
                    $("#my_date_picker1").datepicker({
                        dateFormat: 'dd-mm-yy',
                        beforeShowDay: my_check
                    });
                });
  
                function my_check(in_date) {
                    if (in_date.getDay() == 0) {
                        return [false, "notav", 'Not Available'];
                    } else {
                        return [true, "av", "available"];
                    }
                }
            })
        </script>
   </center>
</body>
  
</html>