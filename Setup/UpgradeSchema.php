<?php

namespace WeProvide\NginxRedirect\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    const NGINX_REDIRECTS_TABLE = 'nginxredirects';

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if ($this->shouldRunUpgrade('1.1.0', $context)) {
            $this->addCreatedAtColumn($setup);
            $this->addUpdatedAtColumn($setup);
        }

        if ($this->shouldRunUpgrade('1.2.0', $context)) {
            $this->addMatchOperatorColumn($setup);
        }

        $setup->endSetup();
    }

    protected function shouldRunUpgrade(string $majorMinorPatch, ModuleContextInterface $context): bool
    {
        return version_compare($context->getVersion(), $majorMinorPatch) < 0;
    }

    protected function addCreatedAtColumn(SchemaSetupInterface $setup)
    {
        $this->addColumn('created_at', [
            'type' => Table::TYPE_TIMESTAMP,
            'default' => Table::TIMESTAMP_INIT,
            'nullable' => false,
            'after' => 'status',
            'comment' => 'Created At'
        ], $setup);
    }

    protected function addUpdatedAtColumn(SchemaSetupInterface $setup)
    {
        $this->addColumn('updated_at', [
            'type' => Table::TYPE_TIMESTAMP,
            'default' => Table::TIMESTAMP_INIT_UPDATE,
            'nullable' => false,
            'after' => 'created_at',
            'comment' => 'Updated At'
        ], $setup);
    }

    protected function addMatchOperatorColumn(SchemaSetupInterface $setup)
    {
        $this->addColumn('match_operator', [
            'type' => Table::TYPE_TEXT,
            'default' => null,
            'nullable' => true,
            'length' => 255,
            'after' => 'target',
            'comment' => 'What match operator to use in the Nginx configuration.'
        ], $setup);
    }

    protected function addColumn(string $columnName, array $definition, SchemaSetupInterface $setup)
    {
        $validTableName = $setup->getConnection()->getTableName(self::NGINX_REDIRECTS_TABLE);
        $setup->getConnection()->addColumn($validTableName, $columnName, $definition);
    }
}
