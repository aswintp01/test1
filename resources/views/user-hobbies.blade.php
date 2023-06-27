<!DOCTYPE html>
<html>

<body>
    <h2>User Hobbies Add</h2>
    <form action="/save-hobbies" method="post">
        @csrf
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="first_name"><br>
        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="last_name"><br><br>
        <label for="fname">Hobbies</label><br>
        @foreach($hobbies as $hobbies)
        <input type="checkbox" id="vehicle1" name="hobbbies[]" value="{{$hobbies->id}}">
        <label for="vehicle1"> {{$hobbies->hobbie_name}}</label><br>
        @endforeach
        <input type="submit" value="Submit">
        @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
        @endforeach
    </form>
</body>

</html>