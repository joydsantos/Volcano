<tr id="inventory-item-<?= $row['id'] ?>">

    <!-- <td class='align-middle text-left'><?= $row['type_name'] ?></td> -->
    <td class='align-middle text-left'><?= $row['item_name'] ?></td>
    <td class='align-middle text-left'><?= $row['brand_model'] ?></td>
    <td class='align-middle text-left'><?= $row['serial_no'] ?></td>
    <td class='align-middle text-left'><?= $row['quantity'] ?></td>
    <td class='align-middle text-left'><?= $row['unitM'] ?></td>
    <td class='align-middle text-left'><?= $row['acquisition_year'] ?></td>
    <td class='align-middle text-left'><?= $row['deployment'] ?></td>
    <td class='align-middle text-left'><?= $row['condition_name'] ?></td>
    <td class='align-middle text-left'><?= $row['action_taken'] ?></td>

    <!-- <td class='align-middle text-left'><?= $row['endorser'] ?></td> -->
    <!-- <td class='align-middle text-left'><?= $row['par_name'] ?></td> -->
    <!-- <td class='align-middle text-left'><?= $row['remarks'] ?></td> -->
    <td class="sticky-col">
        <div class="d-flex">

            <button type="button" class="btnUpdate btn" onclick="editInventoryItem(<?= $row['id'] ?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button type="button" class="btnView btn" onclick="viewInventoryItem(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></button>
            <button type="button" class="btnTrash btn" onclick="confitmDeleteItem(<?= $row['id'] ?>)"><i class="fa fa-trash"></i></button>

        </div>
    </td>
</tr>