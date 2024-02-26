<?php

namespace App\Ldap\Rules;

use Illuminate\Database\Eloquent\Model as Eloquent;
use LdapRecord\Laravel\Auth\Rule;
use LdapRecord\Models\Model as LdapRecord;

class FiltradoUsuarioRegla implements Rule
{
    /**
     * Check if the rule passes validation.
     */
    public function passes(LdapRecord $user, Eloquent $model = null): bool
    {
        // Ejemplos distinguishedname
        //CN=DAW202,OU=DAW2,OU=AlumnosInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local
        //CN=Carmen Iza Castanedo,OU=ProfesoresInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local

        // Obtener las OUs permitidas desde el archivo .env -> LDAP_OUS_PERMITIDAS="OU=Test,DC=petra,DC=local|OU=Test2,DC=petra,DC=local"
        $ousPermitidas = explode('|', env('LDAP_OUS_PERMITIDAS'));

        // Array con OUs permitidas por si falla el .ENV
        /*$ousPermitidas = [
            'OU=ProfesoresInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local'
            'OU=AlumnosInformatica,OU=UsuariosInformatica,OU=IESMHP-Usuarios,DC=iesmhp,DC=local',
        ];*/

        // Comprobar si el atributo distinguishedname contiene alguna de las OUs permitidas
        foreach ($ousPermitidas as $ouPermitida) {
            if (strpos($user->getFirstAttribute('distinguishedname'), $ouPermitida) !== false) {
                return true;
            }
        }

        return false;
    }
}
