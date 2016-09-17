<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TiposParticipantes extends Model
{

    protected $tabla = "tipos_participantes";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    static public function getTiposParticipantes(Request $request, $paginateNumber = 25)
    {
        return TiposParticipantes::Select('id', 'tipo_participante', 'activo')
            ->tipoParticipante($request->get('tipo_participante'))
            ->TipoParticipanteEsActivo($request->get('esActivo'))
            ->orderBy('tipo_participante', 'ASC')
            ->paginate($paginateNumber)
            ->setPath('tiposParticipantes');
    }

    static public function getTiposParticipantesList()
    {
        return ['0' => 'Asistentes...'] + TiposParticipantes::Select('id', 'tipo_participante')
            ->where('activo', true)
            ->orderBy('tipo_participante', 'ASC')
            ->Lists('tipo_participante', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoParticipantes()
    {
        return $this->hasMany("Palencia\Entities\Cursillos");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoParticipante($query, $tipoParticipante)
    {
        if (trim($tipoParticipante) != '') {
            $query->where('tipo_participante', 'LIKE', "$tipoParticipante" . '%');
        }
        return $query;
    }

    public function scopeTipoParticipanteEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('tipos_participantes.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }

}
