<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TiposComunicacionesPreferidas extends Model
{

    protected $tabla = "tipos_comunicaciones_preferidas";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public static function getTipoComunicacionesPreferidasList($placeholder = "Comunicación...")
    {
        return TiposComunicacionesPreferidas::Select('id', 'comunicacion_preferida')
            ->where('activo', true)
            ->orderBy('comunicacion_preferida', 'DESC')
            ->Lists('comunicacion_preferida', 'id') + ['0' => $placeholder];
    }

    static public function getTiposComunicacionesPreferidas(Request $request, $paginateNumber = 25)
    {
        return TiposComunicacionesPreferidas::Select('id', 'comunicacion_preferida', 'tipos_comunicaciones_preferidas.activo')
            ->tipoComunicacionesPreferidas($request->get('comunicacion_preferida'))
            ->TipoComunicacionEsActivo($request->get('esActivo'))
            ->orderBy('comunicacion_preferida', 'ASC')
            ->paginate($paginateNumber)
            ->setPath('tiposComunicacionesPreferidas');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoComunicacionesPreferidas()
    {
        return $this->hasMany("Palencia\Entities\Comunidades");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoComunicacionesPreferidas($query, $comunicacion_preferida)
    {
        if (trim($comunicacion_preferida) != '')
            $query->where('comunicacion_preferida', 'LIKE', "$comunicacion_preferida" . '%');
    }

    public function scopeTipoComunicacionEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('tipos_comunicaciones_preferidas.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }

}
