<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Playlist;
use AppBundle\Entity\Track;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/playlists")
 */
class PlaylistsController extends Controller
{
    /**
     * @Route("/")
     * @Cache(expires="+1 week", public=true, maxage="86400", smaxage="43200")
     */
    public function indexAction()
    {
        $playlistRepository = $this->get('playlist_repository');

        return $this->render('playlists/index.html.twig', [
            'playlists' => $playlistRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/tracks")
     * @ParamConverter("playlist", class="AppBundle:Playlist", options={"repository_method" = "withTracks"})
     * @Cache(
     *      public=true,
     *      lastModified="playlist.getUpdatedAt()",
     *      etag="'Playlist' ~ playlist.getId() ~ playlist.countOfTracks() ~ playlist.getUpdatedAt().format('dmYHis')"
     * )
     */
    public function tracksAction(Playlist $playlist)
    {
        return $this->render('playlists/tracks.html.twig', [
            'playlist' => $playlist
        ]);
    }

    /**
     * @Route("/{id}/tracks/{trackId}")
     * @ParamConverter("track", class="AppBundle:Track", options={"id" = "trackId", "repository_method" = "withAlbumMediaTypeAndGenre"})
     * @Cache(
     *      public=true,
     *      maxage="7200",
     *      smaxage="3600",
     *      expires="+2 day",
     *      lastModified="track.getUpdatedAt()",
     *      etag="'Track' ~ track.getId() ~ track.getUpdatedAt().format('dmYHis')"
     * )
     */
    public function trackAction(Playlist $playlist, Track $track)
    {
        return $this->render('playlists/track.html.twig', [
            'track' => $track
        ]);
    }

    /**
     * @ParamConverter("playlist", class="AppBundle:Playlist", options={"repository_method" = "withTracks"})
     * @Cache(public=true, smaxage="86400")
     */
    public function tracksListAction(Playlist $playlist)
    {
        return $this->render('playlists/tracks-list.html.twig', [
            'playlistId' => $playlist->getId(),
            'tracks' => $playlist->getTracks()
        ]);
    }
}
