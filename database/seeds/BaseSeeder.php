<?php

use Faker\Factory as Faker;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;


/**********************************************************************
 *
 *   Clase base para crear datos de prueba.
 *
 **********************************************************************/
abstract class BaseSeeder extends Seeder {

    protected $total = 50;  // numero de registros a crear
    protected static $pool; // repositorio para generar datos aleatorios

    /**********************************************************************
     *
     *   Metodo para crear datos de prueba llamando al metodo createMultiple
     *   con el numero de registros a crear.
     *
     *   $total: numero de registros a crear
     *
     **********************************************************************/

    public function run()
    {

        $this->createMultiple($this->total);

    }

    /**********************************************************************
     *
     *   Metodo para crear datos de prueba.
     *
     *   $total: numero de registros a crear
     *   $customValues(opcional): array de valores personalizados
     *
     **********************************************************************/
    protected function createMultiple($total, array $customValues = array())
    {

        for ($i = 1; $i <= $total; $i++)
        {

            $this->create($customValues);

        }

    }

    /**********************************************************************
     *
     *   Metodo para especificar el modelo para los datos de prueba que
     *   queremos crear. Crea una nueva instancia de la clase especificada
     *   (modelo)
     *
     **********************************************************************/
    abstract public function getModel();

    /**********************************************************************
     *
     *   Metodo para obtener los datos de prueba generados con Faker
     *
     **********************************************************************/
    abstract public function getDummyData(Generator $faker, array $customValues = array());

    /**********************************************************************
     *
     *   Metodo que acepta tanto valores personalizados o generales para la
     *  generacion de datos de prueba en la tabla con el modelo especificado.
     *
     *  NOTA: los valores personalizados ($customValues) prevalecen sobre los
     *  generales($values).
     *
     **********************************************************************/
    protected function create(array $customValues = array())
    {

        // obtenemos los datos de prueba (opcionalmente pueden ser datos personalizados)
        $values = $this->getDummyData(Faker::create(), $customValues);

        // hacemos un merge de los datos generalizados y los personalizados
        // teniendo preferencia los ultimos.
        $values = array_merge($values, $customValues);

        // actualizamos la tabla correspondiente al modelo especificado
        return $this->addToPool($this->getModel()->create($values));

    }

    /*******************************************************************************
     *
     *   Metodo que crea datos de prueba a partir de los datos existentes
     *   en otra tabla (ejemplo: generar usario_id a partir de los id existentes en la
     *   tabla users). Como en los metodos anteriores tambien acepta valores
     *   personalizados.
     *
     *  $seeder nombre de la clase del seeder(modelo)
     *
     *  $customValues(opcional): array de valores personalizados
     *
     *  Nota: no selecciona los valores aleatoriamente, si no uno de cada
     *
     ******************************************************************************/
    protected function createFrom($seeder, array $customValues = array())
    {

        $seeder = new $seeder;

        return $seeder->create($customValues);

    }

    /*******************************************************************************
     *
     *   Metodo que crea datos de prueba a partir de los datos existentes
     *   en otra tabla (ejemplo: generar usario_id a partir de los id existentes en la
     *   tabla users). Como en los metodos anteriores tambien acepta valores
     *   personalizados.
     *
     *  $model nombre de la clase del seeder(modelo)
     *
     *  Nota: selecciona los valores aleatoriamente de las clases añadidas al repositorio(pool).
     *
     ******************************************************************************/
    protected function getRandom($model)
    {

        // verificamos que el modelo existe en el repositorio
        if ( ! $this->collectionExist($model))
        {

            throw new Exception("La collection del modelo " . $model . " no existe en el repositorio.");

        }

        // devuelve una seleccion aleatoria de los datos del modelo especificado
        return static::$pool[$model]->random();

    }

    /*******************************************************************************
     *
     *   Metodo que añade la clase(modelo) que vayamos creando con los seeders al
     *   repositorio(pool), creando una collection con sus datos.
     *
     *  $entity nombre de la clase del seeder(modelo)
     *
     *  Nota: selecciona los valores aleatoriamente de un repositorio(pool).
     *
     ******************************************************************************/
    protected function addToPool($entity)
    {

        // obtenemos el nombre de la clase sin el namespace
        $reflection = new ReflectionClass($entity);
        $class = $reflection->getShortName();

        // verificamos si la collection para esa clase ya existe y si no la creamos
        if ( ! $this->collectionExist($class))
        {

            static::$pool[$class] = new Collection();

        }

        // añadimos la nueva clase al repositorio
        static::$pool[$class]->add($entity);

        return $entity;

    }

    /*******************************************************************************
     *
     *   Metodo que verifica si la collection especificada existe en el repositorio.
     *
     *  $collection nombre de la collection a verificar.
     *
     ******************************************************************************/
    protected function collectionExist($collection)
    {

        return isset (static::$pool[$collection]);

    }

}