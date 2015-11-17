<?php

namespace Eab\FancyGalleryBundle\Controller;

use Eab\BaseBundle\Helpers\SortHelper;
use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentController extends Controller
{
    /**
     * Inject a pager containing the children of the specified location into the view.
     * Which content types are fetched as children depends on the config setting:
     *
     *     eab_fancy_gallery.image_types
     *
     * The number of children per page is defined by the config setting:
     *
     *     eab_fancy_gallery.page_limit
     *
     * The signature of this method follows the one from the default view controller.
     * @param $locationId
     * @param $viewType
     * @param bool $layout
     * @param array $params
     * @return Response
     */
    public function listChildrenAction( $locationId, $viewType, $layout = false, array $params = array() )
    {
        $repository = $this->getRepository();
        $location = $repository->getLocationService()->loadLocation( $locationId );
        if ( $location->invisible ) {
           throw new NotFoundHttpException( "Location $locationId cannot be displayed as it is flagged as invisible." );
        }

        // Get languages for the current siteaccess
        $languages = $this->getConfigResolver()->getParameter( 'languages' );

        $query = new LocationQuery();
        $query->criterion = new Criterion\LogicalAnd(
                        array(
                            new Criterion\ParentLocationId( $locationId ),
                            new Criterion\Visibility( Criterion\Visibility::VISIBLE ),
                            new Criterion\ContentTypeIdentifier( $this->container->getParameter( 'eab_fancy_gallery.image_types' ) ),
                            new Criterion\LanguageCode( $languages )
                        )
                    );
        // sort children by parent object's sort clause
        $query->sortClauses = array( SortHelper::mapSortClause( $location->sortField, $location->sortOrder ) );

        // Initialize pagination.
        $pager = new Pagerfanta(
            new LocationSearchAdapter( $query, $this->getRepository()->getSearchService() )
        );
        $pager->setMaxPerPage( $this->container->getParameter( 'eab_fancy_gallery.page_limit' ) );
        $pager->setCurrentPage( $this->getRequest()->get( 'page', 1 ) );

        return $this->get( 'ez_content' )->viewLocation(
            $locationId,
            $viewType,
            $layout,
            array(
                'pager' => $pager,
                'pagelayout' => $this->container->getParameter( 'eab_fancy_gallery.pagelayout' ),
                'summaryInFullView' => $this->container->getParameter( 'eab_fancy_gallery.summary_in_full_view' )
            ) + $params
        );
    }

    /**
     * Inject the image variation to use for the gallery thumbnail.
     * The signature of this method follows the one from the default view controller.
     * @param $locationId
     * @param $viewType
     * @param bool $layout
     * @param array $params
     * @return Response
     */
    public function thumbnailAction( $locationId, $viewType, $layout = false, array $params = array() )
    {
        return $this->get( 'ez_content' )->viewLocation(
            $locationId,
            $viewType,
            $layout,
            array(
                'imageVariation' => $this->container->getParameter( 'eab_fancy_gallery.image_variation' )
            ) + $params
        );
    }

}
