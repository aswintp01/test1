<!DOCTYPE html>
<html>

<body>
    <h2>User Hobbies Edit</h2>
    <form action="/update" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{$user['id']}}">
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" name="first_name" value="{{$user['first_name']}}"><br>
        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" name="last_name" value="{{$user['last_name']}}"><br><br>
        <label for="fname">Hobbies</label><br>
        @foreach($hobbies as $hobbies)
        <input type="checkbox" @if(in_array($hobbies->hobbie_name, $existingHobbies)) checked @endif id="vehicle1" name="hobbbies[]" value="{{$hobbies->id}}">
        <label for="vehicle1"> {{$hobbies->hobbie_name}}</label><br>
        @endforeach
        <input type="submit" value="Submit">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </form>
</body>

</html>