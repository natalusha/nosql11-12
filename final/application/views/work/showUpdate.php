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
</style>
<h1>Update work info</h1>
<form action="updateWork" method="POST">
    <input type="hidden" name="workId" value="<?php echo $vars['worksInfo']['id_works']?>">
    <input type="text" value="<?php echo $vars['worksInfo']['work_name'] ?>" name="workName" placeholder="title of the work" required>
    <input type="number" value="<?php echo $vars['worksInfo']['cr_year'] ?>" name="workCreationYear" placeholder="work creation year" required>
    <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Submit</button>
</form>