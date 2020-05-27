<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    form input {
        width: 50vw;
        margin-bottom: 2vh;
    }
    .btn-block {
        width: 50vw;
    }
    h1 {
        text-align: center;
    }
    .all-works-info {
        display: flex;
        width: 100vw
    }
    .all-works-info {
        display: flex;
        width: 97vw;
        padding: 3vh 1vw 3vh 1vw;
        background-color: #e4f0ff;
        margin: 3vh;
    }   
    .all-works-info p{
        margin: 0 2vw 0 0;
        width: 10vw;
    }
    .all-works-header {
        background-color: #ffd6e5; 
    }
    .insert-work{
        display: none;
        transition: .5s;
    }
    .show-insert-form {
        text-align: center;
        font-size: 2em;
        background-color: #e4f0ff;
        width: 25vw;
        margin: 0 35vw;
        transition: .5s;
        cursor: pointer;
    }
    .show-insert-form:hover {
        text-align: center;
        font-size: 3em;
        background-color: #fff;
        width: 25vw;
        margin: 0 35vw;
        transition: .5s;
        cursor: pointer;
    }
    .action-button {
        background-color: #fff;
        margin: 3vh;
        padding: 2vh;
    }
    .update:hover {
        background-color: #71ff89;
    }
    .delete:hover {
        background-color: #fbb;
    }
    .search {
        width: 3vw;
        right: 0;
        position: absolute;
        right: 6vw;
        top: 17vh;
    }
</style>
<a class="select-btn" href="showInsertManyWorks">Insert many works</a></br>
<a class="select-btn" href="showSelect">Select work by author</a>
<div class="show-insert-form" id="showInsertForm">Insert work</div>
<div class="show-insert-form" id="close" style="display:none">Close</div>
<form action="insertWork" method="POST" id="insertWork" class="insert-work">
    <h1>Insert new work info</h1>
    <input type="text" name="firstName" placeholder="First name" required>
    <input type="text" name="secondName" placeholder="Second name" required>
    <input type="text" name="penName" placeholder="Pen name" required>
    <input type="date" name="birthDate" placeholder="birth date" required>
    <input type="date" name="deathDate" placeholder="death date" required>
    <input type="text" name="genre" placeholder="Genre title" required>
    <input type="text" name="countryName" placeholder="Country" required>
    <input type="text" name="cityName" placeholder="City" required>
    <input type="text" name="workName" placeholder="title of the work" required>
    <input type="number" name="workCreationYear" placeholder="work creation year" required>
    <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Submit</button>
</form>
<div class="all-works-info all-works-header">
        <p class="first-name">First name</p>
        <p class="second-name">Second name</p>
        <p class="pen-name">Pen name</p>
        <p class="birth-date">Birth date</p>
        <p class="death-date">Death date</p>
        <p class="genre">Genre</p>
        <p class="country-name">Country</p>
        <p class="city-name">City</p>
        <p class="work-name">Work title</p>
        <p class="works-cr-year">Work creation year</p>
        <a class="action-button update" style="color: transparent; background-color:transparent">update</a>
        <a class="action-button delete" style="color: transparent; background-color:transparent">delete</a>
    </div>
<?php foreach ($vars['allInfo'] as $work):?>
    <div class="all-works-info">
        <p class="first-name"><?php echo $work['frst_name'] ?></p>
        <p class="second-name"><?php echo $work['scnd_name'] ?></p>
        <p class="pen-name"><?php echo $work['pen_name'] ?></p>
        <p class="birth-date"><?php echo $work['birth'] ?></p>
        <p class="death-date"><?php echo $work['death'] ?></p>
        <p class="genre"><?php echo $work['genre_name'] ?></p>
        <p class="country-name"><?php echo $work['country_name'] ?></p>
        <p class="city-name"><?php echo $work['city_name'] ?></p>
        <p class="work-name"><?php echo $work['work_name'] ?></p>
        <p class="works-cr-year"><?php echo $work['cr_year'] ?></p>
        <a class="action-button update" href="showUpdateForm?workId=<?php echo $work['id_works'] ?>" >update</a>
        <a class="action-button delete" href="deleteWork?workToDelete=<?php echo $work['id_works'] ?>">delete</a>
    </div>
<?php endforeach; ?>