<script>
	/**
	 * @license
	 * Copyright 2022 Google LLC. All Rights Reserved.
	 * SPDX-License-Identifier: Apache-2.0
	 */

// Define global variables for the maps and map
	let map, map2
	let center

	/**
	 * Initializes the maps when the page loads.
	 */
	async function initMap () {
		// Load the Map library from Google Maps
		const { Map } = await google.maps.importLibrary('maps')

		// Set the initial center location for the maps
		center = { lat: 41.654987, lng: -91.536598 }

		// Initialize the first map with specified zoom level
		map = new Map(document.getElementById('map'), {
			center: center,
			zoom: 15,
			mapId: 'MAP_1',
			mapTypeId: 'roadmap', // Set the type to default
		})

		// Initialize the second map with different settings, enabling 3D tilt
		map2 = new Map(document.getElementById('map-2'), {
			center: center,
			zoom: 15, // Closer zoom level for detailed
			mapId: 'MAP_2', // Ensure this ID supports 3D
			mapTypeId: 'satellite', // Set the type to satellite
			tilt: 45, // Enable a 3D perspective
			heading: 0, // No initial rotation
		})

		// Attach an event listener to the search button to perform actions on both maps
		document.getElementById('search-button').addEventListener('click', () => {
			findPlaces(map)
			findPlaces(map2)
		})

		// Perform an initial search to populate both maps with a default location
		await findPlaces(map, 'Johnson County Sheriffs Office')
		await findPlaces(map2, 'Johnson County Sheriffs Office')
	}

	/**
	 * Finds and displays places on the given map based on a text query.
	 *
	 * @param {object} map - The map object where places will be displayed.
	 * @param {string} [defaultQuery=''] - The default query to search for if no input is provided.
	 */
	async function findPlaces (map, defaultQuery = '') {
		// Load the Place library for searching places
		const { Place } = await google.maps.importLibrary('places')
		// Load the Marker library to display markers on the map
		const { AdvancedMarkerElement } = await google.maps.importLibrary('marker')

		// Use the value from the input field or a default search query
		const textQuery = document.getElementById('query-input').value || defaultQuery

		// Define the request object for searching by text
		const request = {
			textQuery: textQuery,
			fields: ['displayName', 'location', 'businessStatus'],
			locationBias: center,
			language: 'en-US',
			maxResultCount: 8,
			region: 'us',
		}

		// Execute the search request
		// @ts-ignore: Suppress any potential TypeScript warnings about this line
		const { places } = await Place.searchByText(request)

		if (places.length) {
			console.log(places)

			// Load the core library for dealing with map bounds
			const { LatLngBounds } = await google.maps.importLibrary('core')
			const bounds = new LatLngBounds()

			// Loop through the search results and display each one on the map
			places.forEach((place) => {
				const markerView = new AdvancedMarkerElement({
					map,
					position: place.location,
					title: place.displayName,
				})

				// Extend the bounds of the map to include this place
				bounds.extend(place.location)
				console.log(place)
			})

			// Adjust the map's view to fit all markers
			map.fitBounds(bounds)

			// Force the map to use a specific zoom level after fitBounds
			map.setZoom(15) // Replace `15` with your desired zoom level

		} else {
			console.log('No results')
		}
	}

	initMap()

</script>