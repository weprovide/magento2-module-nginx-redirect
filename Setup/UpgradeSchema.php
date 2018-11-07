<?php
namespace WeProvide\NginxRedirect\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface {
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        if(version_compare($context->getVersion(), '1.1.0') < 0) {
            $setup->getConnection()->addColumn($setup->getConnection()->getTableName('nginxredirects'), 'created_at', [
                'type' => Table::TYPE_TIMESTAMP,
                'default' => Table::TIMESTAMP_INIT,
                'nullable' => false,
                'after' => 'status',
                'comment' => 'Created At'
            ]);

            $setup->getConnection()->addColumn($setup->getConnection()->getTableName('nginxredirects'), 'updated_at', [
                'type' => Table::TYPE_TIMESTAMP,
                'default' => Table::TIMESTAMP_INIT_UPDATE,
                'nullable' => false,
                'after' => 'created_at',
                'comment' => 'Updated At'
            ]);
        }

        $setup->endSetup();
    }
}