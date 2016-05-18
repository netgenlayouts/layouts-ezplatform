<?php

namespace Netgen\Bundle\EzPublishBlockManagerBundle\Layout\Resolver\RuleHandler\Doctrine\TargetHandler;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class Subtree extends Location
{
    /**
     * Handles the query by adding the clause that matches the provided values.
     *
     * @param \Doctrine\DBAL\Query\QueryBuilder $query
     * @param array $values
     *
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function handleQuery(QueryBuilder $query, array $values)
    {
        $query->andWhere(
            $query->expr()->in('rv.value', array(':rule_value'))
        )
        ->setParameter('rule_value', $values, Connection::PARAM_INT_ARRAY);
    }
}