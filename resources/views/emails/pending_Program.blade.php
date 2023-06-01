<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1># Warning</h1>
<p>
    Your trainee name is: {{ $trainee_name }}
    <br>
    course is : {{ $course_name }}
     <br>
    Because you dont paid to  {{ $course_name }} the manager make you pending in this program , <br>
    when you paid the program return accepted again

    <br>
    notes : Program fees is :
    <span class="label font-weight-bold label-lg  label-light-danger label-inline">{{ $fees }}</span>
    <br>
</p>
<hr>
</body>
</html>
