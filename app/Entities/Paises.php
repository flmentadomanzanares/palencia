<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Paises extends Model
{
    protected $tabla = "paises";
    protected $fillable = ['pais']; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public static function getPaisesFromPaisIdToList($id = 0, $placeholder = true, $placeholderText = "País...")
    {
        $sql = Paises::Select('id', 'pais')
            ->where('activo', true)
            ->PaisId($id)
            ->orderBy('pais', 'ASC')
            ->Lists('pais', 'id');
        return $placeholder ? ['0' => $placeholderText] + $sql : $sql;
    }

    public static function getPaisFromProvinciaIdToList($id)
    {
        return Paises::with('provincias')->
        join('provincias', 'pais_id', '=', 'paises.id')->
        select('paises.pais', 'paises.id')->
        where('provincias.id', $id)->
        lists('pais', 'id');
    }

    public static function getPaises(Request $request, $paginateNumber = 25)
    {
        return Paises::pais($request->get('pais'))
            ->PaisEsActivo($request->get('esActivo'))
            ->orderBy('pais', 'ASC')
            ->paginate($paginateNumber)
            ->setPath('paises');
    }

    static public function getNombrePais($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el pais
        return Paises::Select('paises.pais')
            ->where('paises.id', $id)
            ->first();
    }

    public static function getPaisesColaboradores()
    {
        return ['0' => 'País...'] + Paises::Select('paises.id', 'pais')
            ->leftJoin('comunidades', 'comunidades.pais_id', '=', 'paises.id')
            ->where('paises.activo', true)
            ->where('comunidades.esColaborador', true)
            ->orderBy('pais', 'ASC')
            ->Lists('pais', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provincias()
    {
        return $this->hasMany("Palencia\Entities\Provincias");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comunidades()
    {
        return $this->hasMany("Palencia\Entities\Comunidades");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopePais($query, $pais)
    {
        if (trim($pais) != '')
            $query->where('pais', 'LIKE', "$pais" . '%');
    }

    public function scopePaisId($query, $id)
    {
        if (is_numeric($id) && $id > 0)
            $query->where('id', $id);
    }

    public function scopePaisEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }


}
