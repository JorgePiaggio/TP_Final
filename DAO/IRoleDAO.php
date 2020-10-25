<?php
namespace DAO;
    
    use Models\Role as Role;

    interface IRoleDAO{
        function add(Role $role);
        function getAll();
        function search($emailUser);
        function update(Role $role);
    }

?>