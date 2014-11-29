# Elastic TopMenu [![Code Climate](https://codeclimate.com/repos/547949c5695680318e0445f7/badges/384a735b00a00cea7cf5/gpa.svg)](https://codeclimate.com/repos/547949c5695680318e0445f7/feed)

*WIP*

This Magento extension uses elasticsearch as a condensed product information index allowing for speedy tree building

Simply extract to your magento base dir and build your elasticsearch product info index via adminhtml > system > index management

Adheres to Elastica's default of 10 result max - if totalHits > 10 adds a "See more..." item to category's child tree that links to said category.

TODO:

1. Give categories option to enable/disable products in nav
2. Fix index auto update action
3. Fix search and autosuggest
4. Add a layered nav ajax <-> elasticsearch extension for freaky fast filtering
5. Play with building additional indexes within elasticsearch
6. Make composer installable
6. Add Elastica as a composer submodule
