<style>
    .search-res {
        display: flex;
        width: 97vw;
        padding: 3vh 1vw 3vh 1vw;
        background-color: #e4f0ff;
        margin: 3vh;
    }
    p{
        margin: 0 2vw 0 0;
        width: 7vw;
    }
    .search-res-titles {
        display: flex;
        width: 97vw;
        padding: 3vh 1vw 3vh 1vw;
        background-color: #ffd6e5;
        margin: 3vh;
    }
    .back-btn {
        margin: 0 1vw;
    }
</style>
<a class="back-btn" href="showSelect">Back</a>
<div class="search-res-titles">
        <p>Work title<p>
        <p>Year of creation<p>
        <p>First name<p>
        <p>Second name<p>
    </div>
<?php foreach ($vars['result'] as $res): ?>
    <div class="search-res">
        <p><?php echo $res['work_name'] ?><p>
        <p><?php echo $res['cr_year'] ?><p>
        <p><?php echo $res['frst_name'] ?><p>
        <p><?php echo $res['scnd_name'] ?><p>
    </div>
<? endforeach; ?>