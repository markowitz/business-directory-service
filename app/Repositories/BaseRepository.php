<?php

namespace App\Repositories;

class BaseRepository
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function persist(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Undocumented function
     *
     * @return Collection
     */
    public function get()
    {
        return $this->model->get();
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

      /**
     * Updates unique identifier with data passed in
     *
     * @param array $data        Data to update the resource with
     * @param int   $id          Id of resource to update
     * @param array $dataToUnset the data to remove
     *
     * @return mixed
     */
    public function update(array $data, int $id = 0, array $dataToUnset = [])
    {
        $model = $this->model->findOrFail($id);

        // unset sensitive stuff from being accidentally updated
        foreach ($dataToUnset as $unset) {
            if (isset($data[$unset])) {
                unset($data[$unset]);
            }
        }
        if ($model) {
            foreach ($data as $key => $update) {
                $model->$key = $update;
            }
            if ($model->save()) {
                return $model->toArray();
            }
        }
        return false;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}