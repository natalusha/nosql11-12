<style>
    form {
        text-align: center;
    }
</style>
<form action="selectBookByAuthor">
    <select name="authorId">
        <?php foreach ($vars['authors'] as $a): ?>
            <option value="<?php echo $a['id_authors'] ?>"><?php echo $a['frst_name'] ?> <?php echo $a['scnd_name'] ?></option>
        <? endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>