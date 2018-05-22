<?php
namespace AlexRyall\Slider\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            $tableName = $setup->getTable('alexryall_slider_slide');
            $connection = $installer->getConnection();
            $connection->addColumn(
                $tableName,
                'url',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => false,
                    'comment' => 'Slide URL'
                ]
            );
        }

        if (version_compare($context->getVersion(), '2.1.0', '<')) {
            $tableName = $setup->getTable('alexryall_slider_slide');
            $connection = $installer->getConnection();
            $connection->dropColumn($tableName, 'image');
            $connection->dropColumn($tableName, 'url');
            $connection->addColumn(
                $tableName,
                'content',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => false,
                    'comment' => 'Content'
                ]
            );
        }

        $installer->endSetup();
    }
}
