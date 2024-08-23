<tr id="inventory-item-<?= $row['id'] ?>">
    <td class='align-middle text-left'><?= $row['date'] ?></td>
    <td class='align-middle text-left'><?= $row['station_name'] ?></td>
    <td class='align-middle text-left'><?= $row['station_code'] ?></td>
    <td class='align-middle text-left'><?= $row['problem'] ?></td>
    <td class='align-middle text-left'><?= $row['action_taken'] ?></td>
    <td class='align-middle text-left'><?= $row['status_name'] ?></td>
    <td class='align-middle text-left'><?= $row['recommendation'] ?></td>
    <td class='align-middle text-left'><?= $row['remarks'] ?></td>
    <td class='align-middle text-left'><?= $row['field_party'] ?></td>
    <td class='align-middle text-left'><?= $row['photos'] ?></td>
    <td class="sticky-col">
        <div class="d-flex">
            <button type="button" class="btnUpdate btn" onclick="editInventoryItem(<?= $row['id'] ?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button type="button" class="btnView btn" onclick="viewInventoryItem(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></button>
            <button type="button" class="btnTrash btn" onclick="confitmDeleteItem(<?= $row['id'] ?>)"><i class="fa fa-trash"></i></button>
        </div>
    </td>
</tr>