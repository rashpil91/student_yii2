<?php

use app\models\Photo;

?>

<?php if ($model->photo): ?>

    <div class="row">
        <div class="photo_item col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="<?= Photo::getImage($model->photo) ?>" alt="...">
                <div class="caption">
                    <p>
                        <a href="#" class="photo_delete btn btn-danger" data-id="<?= $model->id ?>" role="button">
                            <i class="glyphicon glyphicon-remove"></i>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
