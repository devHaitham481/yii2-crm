<?php

 function getRoles()
    {
        $column_type = ColumnType::find()->all(); 
        return $columnTypes = ArrayHelper::map($column_type, 'name', 'name');
    }

    ?>