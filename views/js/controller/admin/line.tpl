<tr>
    <td>{{label}}</td>
    <td style="display: none">
    {{type}}
        <input type="hidden" name="users[{{user}}][type]" value="{{type}}">
    </td>

    <td>
        <button type="button" class="small delete_permission tooltip btn-link" data-acl-user="{{user}}" data-acl-type="{{type}}" data-acl-label="{{label}}" >
            <span class="icon-remove"></span>{{__ "Remove"}}
        </button>
    </td>
</tr>
