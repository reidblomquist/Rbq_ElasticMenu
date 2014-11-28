# Elastic TopMenu

*WIP*

This Magento extension uses elasticsearch as a condensed product information index allowing for speedy tree building

Simply extract to your magento base dir and build you elasticsearch product info index via adminhtml > system > index management

Adheres to Elastica's default of 10 result max - if totalHits > 10 adds a "See more..." item to category's child tree that links to said category.

TODO:

1. Give categories option to enable/disable products in nav
2. Fix index auto update action
3. Fix search and autosuggest
4. Add a layered nav ajax <-> elasticsearch extension for freaky fast filtering
5. Play with building additional indexes within elasticsearch
