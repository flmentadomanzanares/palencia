<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TiposSecretariados extends Model
{

    protected $tabla = "tipos_secretariados";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoSecretariado()
    {
        return $this->hasMany("Palencia\Entities\Cursillos");
    }

    static public function getTipoSecretariados(Request $request)
    {
        return TiposSecretariados::Select()
            ->TipoSecretariado($request->get('tipo_secretariado'))
            ->orderBy('tipo_secretariado', 'ASC')
            ->paginate()
            ->setPath('tiposSecretariados');
    }

    public static function getTiposSecretariadosList()
    {
        return ['0' => 'Secretariado...'] + TiposSecretariados::Select('id', 'tipo_secretariado')
            ->where('activo', true)
            ->orderBy('tipo_secretariado', 'ASC')
            ->Lists('tipo_secretariado', 'id');
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoSecretariado($query, $tipoSecretariado)
    {
        if (trim($tipoSecretariado) != '')
            $query->where('tipo_secretariado', 'LIKE', "$tipoSecretariado" . '%');
    }

}
