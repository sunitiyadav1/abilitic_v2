<?php 
defined('MOODLE_INTERNAL') || die;

function xmldb_zingilt_install() {
    global $CFG, $OUTPUT, $DB;
    // Your add data code here.
    try{
        //Resource Type
        $table = 'resource_type';
        $tblarr = array();
        $DB->execute("DROP TABLE IF EXISTS `mdl_resource_type`");
        $DB->execute("CREATE TABLE `mdl_resource_type` (
                          `id` int(11) NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `description` text NOT NULL,
                          `is_active` int(11) NOT NULL DEFAULT 0,
                          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                          `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $DB->execute("INSERT INTO `mdl_resource_type` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
            (1, 'FACILITIES', 'FACILITIES', 0, '2019-11-12 01:14:15', '2019-11-12 01:14:15'),
            (2, 'PEOPLE', 'PEOPLE', 0, '2019-11-12 01:14:15', '2019-11-12 01:14:15'),
            (3, 'EQUIPMENTS', 'EQUIPMENTS', 0, '2019-11-12 01:14:54', '2019-11-12 01:14:54')");
 //$record with the role 'name',
 //* 'shortname', 'description' and 'archetype'
        $rollrec = array();
        $rollrec['name'] = 'TRAINER_RM';
        $rollrec['shortname'] = 'TRAINER_RM';
        $rollrec['description'] = "TRAINER_RM";
        $rollrec['archetype'] = 'editingteacher';
        
        $CFG->ZingILT_RM_Roleid = create_trainer_role($rollrec);
        //Resource SubType table creation

        // $table = 'notification_type';
        // $arr = array();
        // $arr[] = array("id"=>1,"name"=>"Email","is_active"=>0,"created_at"=>time(),"upadated_at"=>time());
        // $arr[] = array("id"=>2,"name"=>"App/Mobile","is_active"=>1,"created_at"=>time(),"upadated_at"=>time());
        // $arr[] = array("id"=>3,"name"=>"Web","is_active"=>0,"created_at"=>time(),"upadated_at"=>time());

        // foreach ($arr as $record) {
        //     $r = new stdClass;
        //     $r->id = $record['id'];
        //     $r->name =  $record['name'];
        //     $r->is_active = $record['is_active'];
        //     $r->created_at =$record['created_at'];
        //     $r->upadated_at = $record['upadated_at'];
        //     $DB->insert_record('notification_type', $r);
        // }
    }
    catch(Exception $e){    
    }
}
  /**
     * Creates a new role in the system.
     *
     * You can fill $record with the role 'name',
     * 'shortname', 'description' and 'archetype'.
     *
     * If an archetype is specified it's capabilities,
     * context where the role can be assigned and
     * all other properties are copied from the archetype;
     * if no archetype is specified it will create an
     * empty role.
     *
     * @param array|stdClass $record
     * @return int The new role id
     */
    function create_trainer_role($record=null) {
        global $DB;
        $record = (array)$record;

        if (empty($record['shortname'])) {
            $record['shortname'] = 'role-' . $i;
        }

        if (empty($record['name'])) {
            $record['name'] = 'Test role ' . $i;
        }

        if (empty($record['description'])) {
            $record['description'] = 'Test role ' . $i . ' description';
        }
            $record['archetype'] = "editingteacher";
         /*   if (empty($record['archetype'])) {
                $record['archetype'] = '';
            } else {
                $archetypes = get_role_archetypes();
                if (empty($archetypes[$record['archetype']])) {
                    throw new coding_exception('\'role\' requires the field \'archetype\' to specify a ' .
                        'valid archetype shortname (editingteacher, student...)');
                }
            }*/

        // Creates the role.
        if (!$newroleid = create_role($record['name'], $record['shortname'], $record['description'], $record['archetype'])) {
            throw new coding_exception('There was an error creating \'' . $record['shortname'] . '\' role');
        }

        // If no archetype was specified we allow it to be added to all contexts,
        // otherwise we allow it in the archetype contexts.
        if (!$record['archetype']) {
            $contextlevels = array_keys(context_helper::get_all_levels());
        } else {
            // Copying from the archetype default rol.
            $archetyperoleid = $DB->get_field(
                'role',
                'id',
                array('shortname' => $record['archetype'], 'archetype' => $record['archetype'])
            );
            $contextlevels = get_role_contextlevels($archetyperoleid);
            $contextlevels[]= CONTEXT_SYSTEM;
        }
        set_role_contextlevels($newroleid, $contextlevels);

        if ($record['archetype']) {

            // We copy all the roles the archetype can assign, override, switch to and view.
            if ($record['archetype']) {
                $types = array('assign', 'override', 'switch', 'view');
                foreach ($types as $type) {
                    $rolestocopy = get_default_role_archetype_allows($type, $record['archetype']);
                    foreach ($rolestocopy as $tocopy) {
                        $functionname = "core_role_set_{$type}_allowed";
                        $functionname($newroleid, $tocopy);
                    }
                }
            }

            // Copying the archetype capabilities.
            $sourcerole = $DB->get_record('role', array('id' => $archetyperoleid));
            role_cap_duplicate($sourcerole, $newroleid);
        }

        return $newroleid;
    }

function get_trainer_role(){
    $roles = role_fix_names(get_all_roles(), \context_system::instance(), ROLENAME_ORIGINAL);
    print_r($roles);
        $rolesnames = array();
        foreach ($roles as $role) {
            if(trim($role->localname) == "TRAINER_RM1"){
                $rolesnames[$role->id] = $role->localname;
                return $role;
            }
        }
       return $rolesnames;       
  }
