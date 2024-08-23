<tr id="equipment-item-<?= $row['id'] ?>" class="item-row">
    <td class='align-middle text-left'><?= $row['station_name'] ?></td>
    <td class='align-middle text-left'><?= $row['location'] ?></td>
    <td class='align-middle text-left'><?= $row['station_code'] ?></td>
    <td class='align-middle text-left'><?= str_replace(",", "<br>", $row['instruments']) ?></td>
    <td>
        <div class="d-flex justify-content-left justify-content-md-left align-middle">
            <button type="button" class="btnUpdate btn" onclick="editEquipmentItem(<?= $row['id'] ?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button type="button" class="btnView btn" onclick="viewEquipmentItem(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></button>
            <button type="button" class="btnTrash btn" onclick="confirmDeleteItem(<?= $row['id'] ?>)"><i class="fa fa-trash"></i></button>
        </div>
    </td>

</tr>