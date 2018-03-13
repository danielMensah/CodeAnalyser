// Mike Scott
// 2d array manipulation examples

//import
import java.awt.Color;


{
	/*
	 *pre: image != null, image.length > 1, image[0].length > 1
	 *	image is a rectangular matrix, neighberhoodSize > 0
	 *post: return a smoothed version of image
	 */
	public Color[][] smooth(Color[][] image, int neighberhoodSize)
	{	//check precondition
		assert image != null && image.length > 1 && image[0].length > 1
				&& ( neighberhoodSize > 0 ) && rectangularMatrix( image )
				: "Violation of precondition: smooth";

		Color[][] result = new Color[image.length][image[0].length];

		for(int row = 0; row < image.length; row++)
		{	for(int col = 0; col < image[0].length; col++)
			{	result[row][col] = aveOfNeighbors(image, row, col, neighberhoodSize);
			}
		}

		return result;
	}
}