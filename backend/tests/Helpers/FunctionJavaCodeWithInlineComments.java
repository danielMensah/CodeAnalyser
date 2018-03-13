	public Color[][] smooth(Color[][] image, int neighberhoodSize)
		{ //check precondition if
		assert image != null && image.length > 1 && image[0].length > 1
				&& ( neighberhoodSize > 0 ) && rectangularMatrix( image )
				: "Violation of precondition: smooth";

		Color[][] result = new Color[image.length][image[0].length];

		for(int row = 0; row < image.length; row++) //test comment if else
		{	for(int col = 0; col < image[0].length; col++)
			{	result[row][col] = aveOfNeighbors(image, row, col, neighberhoodSize); /* just an inline comment with if */
			}
		}

		do {
            System.out.println("Count is: " + count);
            count++;
        } while (count < 11);

		return result;
	}