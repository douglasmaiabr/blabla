<?php

namespace N98Hackathon\BlaBla\Observer;

use Magento\Framework\Event\Observer;
use Magento\Sales\Api\Data\OrderInterface;
use N98Hackathon\BlaBla\Channel\ChannelPool;

/**
 * Class OrderPurchaseNotificationObserver
 */
class OrderPurchaseNotificationObserver
{
    /**
     * @var ChannelPool
     */
    protected $channelPool;

    /**
     * OrderPurchaseNotificationObserver constructor.
     *
     * @param ChannelPool $channelPool
     */
    public function __construct(ChannelPool $channelPool)
    {
        $this->channelPool = $channelPool;
    }

    /**
     * Submit notification after success order placement
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var OrderInterface $order */
        $order = $observer->getData('order');
        $total = $order->getGrandTotal();

        $channels = $this->channelPool->getChannels();

        foreach ($channels as $channel) {
            $channel->send('New order placed: ' . $total);
        }
    }
}
