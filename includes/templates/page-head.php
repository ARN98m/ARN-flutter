<div class="page-head">
    <h1 class="page-title">
        <?php

        if (getTitle() == "HomePage") {
            echo lang('homePage');
        } elseif (getTitle() == "Manage") {
            echo lang('manage');
        } elseif (getTitle() == "My history") {
            echo lang('historyPage');
        }
         elseif (getTitle() == "SalesPage") {
            echo lang('SalesPage');
        }

        ?></h1>
    <p class="page-description">
        <?php
        if (getTitle() == "HomePage") {
            echo lang('desc page')["homePage"];
        } elseif (getTitle() == "Manage") {
            echo lang('desc page')["manage"];
        } elseif (getTitle() == "My history") {
            echo lang('desc page')["history Page"];
        }
         elseif (getTitle() == "SalesPage") {
            echo lang('desc page')["SalesPage"];
        }

        ?></p>
</div>