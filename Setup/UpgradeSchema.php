<?php
namespace WeProvide\NginxRedirect\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        // handle all possible upgrade versions

        if (!$context->getVersion()) {
            //no previous version found, installation, InstallSchema was just executed
            //be careful, since everything below is true for installation !
        }

        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $step = $setup->getConnection()->newTable($setup->getTable('nginxredirects'));

            $step->addColumn(
                'redirect_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ),
                'Redirect ID'
            );

            $step->addColumn(
                'source',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Source path'
            );

            $step->addColumn(
                'target',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Go to target'
            );

            $step->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                '301 or 302'
            );

            $setup->getConnection()->createTable($step);
        }


        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('nginxredirects')
            )->addColumn(
                'redirect_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true, ),
                'Redirect ID'
            )->addColumn(
                'source',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Source path'
            )->addColumn(
                'target',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Go to target'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                '301 or 302'
            );
            $installer->getConnection()->createTable($table);
        }


        $installer->endSetup();
    }
}
