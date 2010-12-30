<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Cache;

use Doctrine\Common\Cache\AbstractCache;

class MongoCache extends AbstractCache
{
    /**
     *.
     * @param Mongo instance $mongo
     */
    public function setMongo(\Mongo $mongo, $database, $collection)
    {
        $this->collection = $mongo->selectCollection($database, $collection);
    }

    /**
     * {@inheritdoc}
     */
    public function getIds()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    protected function _doFetch($id)
    {
        $cache = $this->collection->findOne(array('key' => $id, array('data')));

        return $cache ? $cache['data'] : null;
    }

    /**
     * {@inheritdoc}
     */
    protected function _doContains($id)
    {
        return null !== $this->collection->findOne(array('key' => $id));
    }

    /**
     * {@inheritdoc}
     */
    protected function _doSave($id, $data, $lifeTime = 0)
    {
        return (bool) $this->collection->save(array('key' => $id, 'data' =>  new \MongoBinData($data)));
    }

    /**
     * {@inheritdoc}
     */
    protected function _doDelete($id)
    {
        return $this->collection->remove(array('key' => $id));
    }
}